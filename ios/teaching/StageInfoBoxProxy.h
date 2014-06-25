//
//  StageInfoBoxProxy.h
//  teaching
//
//  Created by kidliuxu on 14-1-7.
//  Copyright (c) 2014年 icesmart. All rights reserved.
//

#import <Foundation/Foundation.h>

@interface StageInfoBoxProxy : NSObject

@property (nonatomic,retain) NSString *infoType;

- (id) initWithInfoType:(NSString *) infoTypeStr;

- (void) saveStrValueByKey:(NSString *) infoKey value:(NSObject *) infoValue;
- (void) saveBoolValueByKey:(NSString *) infoKey value:(BOOL) infoValue;
- (void) saveIntValueByKey:(NSString *) infoKey vlaue:(int) infoValue;

- (NSString *) loadStrValueByKey:(NSString *) infoKey;
- (BOOL) loadBoolValueByKey:(NSString *) infoKey;
- (int) loadIntValueByKey:(NSString *) infoKey;

@end
