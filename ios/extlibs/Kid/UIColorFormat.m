//
//  UIColorFormat.m
//  teaching
//
//  Created by kidliuxu on 14-1-14.
//  Copyright (c) 2014年 icesmart. All rights reserved.
//

#import "UIColorFormat.h"

@implementation UIColorFormat

+(UIColor *) getUIColorByHEX:(int)hexNum
{
    //NSLog(@"hexnum: %i", ((hexNum>>16)));
    //NSLog(@"hexnum: %x", (hexNum>>8) - (hexNum>>16<<8));
    //NSLog(@"hexnum: %x", (hexNum) - (hexNum>>8<<8));
    CGFloat redColor = (hexNum>>16) / 255.0;
    CGFloat greenColor = ((hexNum>>8) - (hexNum>>16<<8)) / 255.0;
    CGFloat blueColor = ((hexNum) - (hexNum>>8<<8)) / 255.0;
    UIColor *uiColor = [UIColor colorWithRed:redColor green:greenColor blue:blueColor alpha:1.0];
    return uiColor;
}

@end
